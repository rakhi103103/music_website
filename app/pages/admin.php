<?php

if(!is_admin())
{
        message("only admin can access the admin page");
        redirect('login/');
} 

        $URL = explode('/',trim($_SERVER['REQUEST_URI'],'/'));


        $section     = $URL[3] ?? null;
        $action      = $URL[4] ?? null;
        $id          = $URL[5] ?? null;

        
        switch ($section) {
                case 'user':
                        require page('admin/user');
                        break;

                case 'category':
                         require page('admin/category');
                         break;

                case 'artist':
                        require page('admin/artist');
                        break;
                
                case 'songs':
                        require page('admin/songs');
                        break;

                case 'dashboard':
                         require page('admin/dashboard');
                         break;
                
                default:
                require page('admin/404');
                        break;
        }







            