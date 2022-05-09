<?php

namespace App\Modules\Employee\Services;

use App\Helpers\TransformerResponse;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Modules\Employee\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class EmployeeService implements EmployeeServiceInterface
{

    private $transformerResponse;
    private $employeeRepository;
    const   ID_NOT_EXIST            =   'id does not exist';
    const   DELETE_FAILED_MESSAGE   =   'Deletion failed' ;

    public function __construct(
        TransformerResponse         $transformerResponse,
        EmployeeRepositoryInterface $employeeRepository
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->employeeRepository  = $employeeRepository;
    }

    /**
     * get list all employees
     *
     * @return reponse
     */
    public function getAll()
    {
        try {
            $employees = $this->employeeRepository->getAll();
            return $this->transformerResponse->response(
                false,
                [
                    'Employees' => $employees
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }

    }

    /**
     * Create Employee
     *
     * @param $requests
     * @return reponse
     */
    public function create($requests)
    {
        try {
            $data = $requests->validated();
            $employee = $this->employeeRepository->create($data);
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_CREATED,
                TransformerResponse::CREATE_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

    /**
     * Update Employee to by id
     *
     * @param $requests, $id
     * @return reponse
     */
    public function update($requests, $id)
    {
        try {

            $validated = $requests->validated();
             // check if employee id exists
            $employee = $this->employeeRepository->getById($id);
            if(empty($employee))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );
            $data = [
                'name'          =>  $validated['name'],
                'email'         =>  $validated['email'],
                'position'      =>  $validated['position'],
                'company_id'    =>  $validated['company_id']
            ];
            // update employee
            $employee = $this->employeeRepository->updateById($data, $id);
            return $this->transformerResponse->response(
                false,
                [
                    'Employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::UPDATE_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }

    }

     /**
     * Delete Employee to by id
     *
     * @param $id
     * @return reponse
     */
    public function delete($id)
    {
        try {
            // check if employee id exists
            $employee = $this->employeeRepository->getById($id);
            if(empty($employee))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NOT_FOUND,
                    self::ID_NOT_EXIST
                );
             // Check if deletion is successful or not and delete
            if(!$this->employeeRepository->deleteById($id))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NO_CONTENT,
                    self::DELETE_FAILED_MESSAGE
                );

            return $this->transformerResponse->response(
                false,
                [],
                TransformerResponse::HTTP_OK,
                TransformerResponse::DELETE_SUCCESS_MESSAGE
            );

        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }
     /**
     * get Employees to by Company id
     *
     * @param $companyId
     * @return reponse
     */
    public function getEmployeesToByCompanyId($companyId)
    {
        try {
            // check if company id exists
            $employees = $this->employeeRepository->getByCompanyId($companyId);
            if(empty($employees))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );
            return $this->transformerResponse->response(
                false,
                [
                    'Employees' => $employees
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

    /**
     * get Employee to by id
     *
     * @param $id
     * @return reponse
     */
    public function getEmployee($id)
    {
        try {
            // check if employee id exists
            $employee = $this->employeeRepository->getById($id);
            if(empty($employee))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );

            return $this->transformerResponse->response(
                false,
                [
                    'Employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

}
