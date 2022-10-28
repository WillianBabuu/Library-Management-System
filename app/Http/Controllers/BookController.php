<?php

namespace App\Http\Controllers;

use App\Models\Enum\EnumFormMethod;
use App\Util\JsonResponse;
use App\Util\LoggerUtil;
use App\Service\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    protected $bookService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        /*$this->middleware('auth:sanctum');*/
        $this->bookService = $bookService;
    }

    public function get(Request $request)
    {
        $id = $request->id;
        $bookBook = $this->bookService->get($id);

        $returnData = null;
        $errorMessage = "Book not found";
        $returnStatus = JsonResponse::$ERROR;
        if($bookBook) {
            $returnData = array(
                'item' => $bookBook
            );
            $errorMessage = "Book found";
            $returnStatus = JsonResponse::$OK;
        }
        return response()->json(JsonResponse::get($returnStatus, $errorMessage, $returnData));
    }

    public function search(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $l = $request->l;
        $paginate = $request->paginate;
        $current_page = $request->current_page;
        $user_id = $request->user()->id;
        $popular = $request->popular;

        $extraBook = array();
        if (!empty($user_id)) {
            $extraBook = array_merge($extraBook, array('user_id' => $user_id));
        }
        if (!empty($popular)) {
            $extraBook = array_merge($extraBook, array('popular' => $popular));
        }

        $listOfBook = $this->bookService->search($id, $name, $l, $extraBook);
        if ($request->paginate) {
            $listOfBook = $this->bookService->paginate($listOfBook,$paginate,$current_page);
        }

        $returnData = null;
        if($listOfBook) {
            $returnData = array(
                'list_of_items' => $listOfBook
            );
        }
        return response()->json(JsonResponse::get(JsonResponse::$OK, "List Of Books", $returnData));
    }

    public function action(Request $request)
    {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");
        $rules = $this->bookService->validationRules();

        try {
            $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                $output = JsonResponse::get(JsonResponse::$ERROR, $error->errors()->all());
                return response()->json($output);
            }

            $formMethod = $request->form_method;

            if($formMethod === EnumFormMethod::get('UPDATE/value')){
                $id = $request->id;
                $book = $this->bookService->update($request, $id);
                $output = JsonResponse::get(JsonResponse::$OK, "Book Updated successful", $book);
                return response()->json($output);
            } else {

                $book = $this->bookService->save($request);
                $output = JsonResponse::get(JsonResponse::$OK, "Book saved successful", $book);
                return response()->json($output);
            }
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }

    public function like(Request $request)
    {
        try {
            $id = $request->id;
            $user_id = $request->user()->id;
            $book = $this->bookService->one($id,null);
            $book->user_like()->toggle($user_id);
            $output = JsonResponse::get(JsonResponse::$OK, "Book Liked successful", $book);
            return response()->json($output);
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }

    public function favourite(Request $request)
    {
        try {
            $id = $request->id;
            $user_id = $request->user()->id;
            $book = $this->bookService->one($id,null);
            $book->favourite()->toggle($user_id);
            $output = JsonResponse::get(JsonResponse::$OK, "Book Liked successful", $book);
            return response()->json($output);
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }

    public function delete($id) {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");

        try {
            $delete = $this->bookService->delete($id);
            if ($delete) {
                $output = JsonResponse::get(JsonResponse::$OK, "Book Deleted Successful");
            } else {
                $output = JsonResponse::get(JsonResponse::$ERROR, "Book can not be deleted!!");
            }
            return response()->json($output);

        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }
}
