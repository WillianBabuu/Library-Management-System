<?php

namespace App\Http\Controllers;

use App\Models\Enum\EnumFormMethod;
use App\Util\JsonResponse;
use App\Util\LoggerUtil;
use App\Service\BookService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FakerController extends Controller
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



    public function action(Request $request)
    {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");
        $rules = $this->bookService->validationRules();

        try {
            $faker = Factory::create();

            for ($i = 0; $i < 5000; $i++) {
                $request->name = $faker->realText(rand(20,30));
                $request->author = $faker->name;
                $request->year_published = $faker->year($max = 'now');
                $book = $this->bookService->save($request);
                
                $output = JsonResponse::get(JsonResponse::$OK, "Book saved successful", $book);
            }
                return response()->json($output);
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }

}
