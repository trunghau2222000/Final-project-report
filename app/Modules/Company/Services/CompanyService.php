<?php

namespace App\Modules\Company\Services;

use App\Helpers\TransformerResponse;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Modules\Company\Services\Interfaces\CompanyServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class CompanyService implements CompanyServiceInterface
{

    private $transformerResponse;
    private $companyRepository;
    const   ID_NOT_EXIST            =   'id does not exist';
    const   DELETE_FAILED_MESSAGE   =   'Deletion failed' ;

    public function __construct(
        TransformerResponse $transformerResponse,
        CompanyRepositoryInterface $CompanyRepository
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->companyRepository = $CompanyRepository;
    }

    /**
     * get list all Companies
     *
     * @return reponse
     */
    public function getAll()
    {
        try {
            $companies = $this->companyRepository->getAll();
            return $this->transformerResponse->response(
                false,
                [
                    'Compannies' => $companies
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
     * Create Company
     *
     * @param $requests
     * @return reponse
     */
    public function create($requests)
    {
        try {
            $data = $requests->validated();
            $company = $this->companyRepository->create($data);
            return $this->transformerResponse->response(
                false,
                [
                    'Company' => $company
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
     * Update company to by id
     *
     * @param $requests, $id
     * @return reponse
     */
    public function update($requests, $id)
    {
        try {

            $validated = $requests->validated();

            // check if company id exists
            $company = $this->companyRepository->getById($id);
            if(empty($company))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );

            // set value data update
            $data = [
                'name'    =>  $validated['name'],
                'address' =>  $validated['address']
            ];
            // update Copany
            $company = $this->companyRepository->updateById($data, $id);
            return $this->transformerResponse->response(
                false,
                [
                    'Company' => $company
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
     * Delete company to by id
     *
     * @param  $id
     * @return reponse
     */
    public function delete($id)
    {
        try {
            // check if company id exists
            $company = $this->companyRepository->getById($id);
            if(empty($company)) {
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NOT_FOUND,
                    self::ID_NOT_EXIST
                );
            }
            // Check if deletion is successful or not and delete
            if(!$this->companyRepository->deleteById($id)) {
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NO_CONTENT,
                    self::DELETE_FAILED_MESSAGE
                );
            }
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
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE . $exception->getMessage()
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
     * get company to by id
     *
     * @param  $id
     * @return reponse
     */
    public function getCompany($id)
    {
        try {
            // check if company id exists
            $company = $this->companyRepository->getById($id);
            if(empty($company))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );

            return $this->transformerResponse->response(
                false,
                [
                    'Compannies' => $company
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
