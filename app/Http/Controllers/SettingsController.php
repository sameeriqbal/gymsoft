<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $settings = \Utilities::getSettings();

        return view('settings.show', compact('settings'));
    }

    public function edit()
    {
        $settings = \Utilities::getSettings();

        return view('settings.edit', compact('settings'));
    }

    public function save(Request $request)
    {
        // Get All Inputs Except '_Token' to loop through and save
        $settings = $request->except('_token');

        // Update All Settings
        foreach ($settings as $key => $value) {
            if ($key == 'gym_logo') {
                \Utilities::uploadFile($request, '', $key, 'gym_logo', \constPaths::GymLogo); // Upload File
                $value = $key.'.jpg'; // Image Name For DB
            }

            Setting::where('key', '=', $key)->update(['value' => $value]);
        }
        $this->something();
        flash()->success('Setting was successfully updated');

        return redirect('settings/edit');
    }

    public function something(){
        $settings = \Utilities::getSettings();
        $env_update = $this->changeEnv([
            'APP_NAME'   => ''.$settings['gym_name'].''
        ]);
        if($env_update){
            // Do something
        } else {
            // Do something else
        }
        // more code
    }

    protected function changeEnv($data = array()){
        if(count($data) > 0){

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){

                // Loop through .env-data
                foreach($env as $env_key => $env_value){

                    // Turn the value into an array and stop after the first split
                    // So it's not possible to split e.g. the App-Key by accident
                    $entry = explode("=", $env_value, 2);

                    // Check, if new key fits the actual .env-key
                    if($entry[0] == $key){
                        // If yes, overwrite it with the new one
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        // If not, keep the old one
                        $env[$env_key] = $env_value;
                    }
                }
            }

            // Turn the array back to an String
            $env = implode("\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } else {
            return false;
        }
    }
}
