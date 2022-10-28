<?php

namespace App\Http\Controllers;

use App\Models\Enum\EnumFormMethod;
use App\Service\CompanyService;
use App\Util\JsonResponse;
use App\Util\LoggerUtil;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $userService;
    protected $companyService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, CompanyService $companyService)
    {
        /*$this->middleware('auth:sanctum');*/
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function get(Request $request)
    {
        $id = $request->id;
        $userUser = $this->userService->get($id);

        $returnData = null;
        $errorMessage = "User not found";
        $returnStatus = JsonResponse::$ERROR;
        if($userUser) {
            $returnData = array(
                'item' => $userUser
            );
            $errorMessage = "User found";
            $returnStatus = JsonResponse::$OK;
        }
        return response()->json(JsonResponse::get($returnStatus, $errorMessage, $returnData));
    }

    public function search(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $l = $request->l;

        $extraUser = array( 'company_id' => $request->current_company_id );

        $listOfUser = $this->userService->search($id, $name, $l, $extraUser);

        $returnData = null;
        if($listOfUser) {
            $returnData = array(
                'list_of_users' => $listOfUser
            );
        }
        return response()->json(JsonResponse::get(JsonResponse::$OK, "List Of Users", $returnData));
    }

    public function searchUsersInCompany(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
        $l = $request->l;
        $company_id = $request->current_company_id;

        $extraUser = array( 'with_user_store' => $request->with_user_store );

        $listOfUser = $this->companyService->getCompanyWithUsers($company_id);

        $returnData = null;
        if($listOfUser) {
            $returnData = array(
                'list_of_users' => $listOfUser
            );
        }
        return response()->json(JsonResponse::get(JsonResponse::$OK, "List Of Users", $returnData));
    }

    public function action(Request $request)
    {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");
        $rules = $this->userService->validationRules();

        try {
            $error = Validator::make($request->all(), $rules);

            if ($error->fails()) {
                $output = JsonResponse::get(JsonResponse::$ERROR, $error->errors()->all());
                return response()->json($output);
            }

            $formMethod = $request->form_method;

            if($formMethod === EnumFormMethod::get('UPDATE/value')){
                $id = $request->id;
                $user = $this->userService->update($request, $id);

                $output = JsonResponse::get(JsonResponse::$OK, "User Updated successful", $user);
                return response()->json($output);
            } else {
                $request->company_id = $request->current_company_id;
                $request->created_by = $request->user()->id;
                $unencrypted = $request->password;
                $request->password = bcrypt($unencrypted);
                $user = $this->userService->save($request);
                $user->companies()->attach($request->company_id);
                $user->stores()->attach($request->company_id);
                $output = JsonResponse::get(JsonResponse::$OK, "User saved successful", $user);
                return response()->json($output);
            }
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }

    public function delete($id, Request $request) {
        $output = JsonResponse::get(JsonResponse::$ERROR, "Ooops something went wrong !!");

        try {
            if ($request->user()->id != $id){
                $delete = $this->userService->delete($id);
                if ($delete) {
                    $output = JsonResponse::get(JsonResponse::$OK, "User Deleted Successful");
                } else {
                    $output = JsonResponse::get(JsonResponse::$ERROR, "User can not be deleted!!");
                }
            }else{
                $output = JsonResponse::get(JsonResponse::$ERROR, "You Cannot Delete Yourself!!");
            }
            return response()->json($output);

        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return response()->json(JsonResponse::get(JsonResponse::$ERROR, $e->getMessage()));
        }
    }
}
