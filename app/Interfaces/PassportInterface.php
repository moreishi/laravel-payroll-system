<?php


namespace App\Interfaces;


use Illuminate\Http\Request;

interface PassportInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request);

    /**
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request);
}