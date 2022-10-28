<?php

namespace App\Http\Controllers;

use App\Models\Enum\EnumFormMethod;
use App\Util\JsonResponse;
use App\Util\LoggerUtil;
use App\Service\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    protected $commentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CommentService $commentService)
    {
        /*$this->middleware('auth:sanctum');*/
        $this->commentService = $commentService;
    }

    public function get(Request $request)
    {
        $id = $request->id;
        $commentComment = $this->commentService->get($id);

        $returnData = null;
        $errorMessage = "Comment not found";
        $returnStatus = JsonResponse::$ERROR;
        if($commentComment) {
            $returnData = array(
                'comment' => $commentComment
            );
            $errorMessage = "Comment found";
            $returnStatus = JsonResponse::$OK;
        }
        return response()->json(JsonResponse::get($returnStatus, $errorMessage, $returnData));
    }

    public function search(Request $request)
    {
        $id = $request->id;
        $book_id = $request->book_id;
        $l = $request->l;

        $extraComment = array();

        $listOfComment = $this->commentService->search($id, $book_id, $l, $extraComment);

        $returnData = null;
        if($listOfComment) {
            $returnData = array(
                'list_of_items' => $listOfComment
            );
        }
        return response()->json(JsonResponse::get(JsonResponse::$OK, "List Of Comments", $returnData));
    }

    public function action(Request $request)
    {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");
        $rules = $this->commentService->validationRules();

        try {
            $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                $output = JsonResponse::get(JsonResponse::$ERROR, $error->errors()->all());
                return response()->json($output);
            }

            $formMethod = $request->form_method;

            if($formMethod === EnumFormMethod::get('UPDATE/value')){
                $id = $request->id;
                $comment = $this->commentService->update($request, $id);
                $output = JsonResponse::get(JsonResponse::$OK, "Comment Updated successful", $comment);
                return response()->json($output);
            } else {
                $comment = $this->commentService->save($request);
                $output = JsonResponse::get(JsonResponse::$OK, "Comment saved successful", $comment);
                return response()->json($output);
            }
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }
    public function delete($id) {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");

        try {
            $delete = $this->commentService->delete($id);
            if ($delete) {
                $output = JsonResponse::get(JsonResponse::$OK, "Comment Deleted Successful");
            } else {
                $output = JsonResponse::get(JsonResponse::$ERROR, "Comment can not be deleted!!");
            }
            return response()->json($output);

        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }
}
