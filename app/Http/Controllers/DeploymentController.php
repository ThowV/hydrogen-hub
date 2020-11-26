<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class DeploymentController extends Controller
{


    /**
     * DeploymentController constructor.
     */
    public function __construct()
    {
        $this->prodToken = "dqnj9u7381bE!X&*B&#yr72834r9j2s829748d0h23g657gYG&^hx9tr76";
        $this->devToken = 'HuyvgUYVD76%^^&5gYUBVD&91bYu';
        $this->token = 'https://requestinspector.com/inspect/01er2axxeq0daextc4z9xq48kb';
    }

    public function deploy()
    {
        $glToken = false;
        foreach (getallheaders() as $header => $value) {
            if (strtolower($header) == 'x-gitlab-token') {
                $glToken = true;
                if ($value == $this->prodToken) {
                    //valid request
                    Log::info('Trying to pull master on the remote rempository with token:' . $value);
                    Log::debug(shell_exec('git pull origin master'));

                    $res = shell_exec("composer install");
                } elseif ($value == $this->devToken) {
                    Log::info('Trying to pull develop on the remote rempository with token:' . $value);
                    $res = shell_exec("git reset --hard");
                    Log::debug(shell_exec('git pull origin develop'));

                    $res = shell_exec("composer install");
                    $res = shell_exec("php artisan migrate:fresh");
                    $res = shell_exec("php artisan db:seed");

                }
            }
        }

        if (!$glToken) {
            Log::error("the x-github-token header was not present");
        }
    }

    public function message($message)
    {
        Log::debug($message);
    }
}
