<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ToolsRepositories;
use Exception;

class ToolsController extends Controller
{
    /**
     * @var ToolsRepositories
     */
    private $toolsRepositories;

    /**
     * @param ToolsRepositories $toolsRepositories
     */
    public function __construct(ToolsRepositories $toolsRepositories)
    {
        $this->toolsRepositories = $toolsRepositories;
    }

    public function index()
    {
        try {
            $tools = $this->toolsRepositories->getAllWithTags();
            return response()->json($tools);
        } catch(Exception $exception) {

        }
    }
}
