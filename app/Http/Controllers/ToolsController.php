<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use App\Http\Requests\ToolsRequest;
use App\Repositories\ToolsRepositories;

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
            return response()->json([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function store(ToolsRequest $request)
    {
        try {
            $tool = $this->toolsRepositories->create($request->all());
            if ($tool)
                return response()->json($tool, Response::HTTP_CREATED);

            response()->json([], Response::HTTP_CREATED);
        } catch(Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
