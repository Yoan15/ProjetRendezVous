<?php

namespace App\Controller;

use App\DTO\PatientDTO;
use App\Entity\Patient;
use App\Mapper\PatientMapper;
use FOS\RestBundle\View\View;
use App\Service\PatientService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\PatientServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @OA\Info(
 *   title="DocNoProblemo Management",
 *   version="1.0.0",
 *   title="DocNoProblemo Management"
 *   )
 * )
 */
class PatientRestController extends AbstractFOSRestController
{
    private $patientService;

    const URI_PATIENT_COLLECTION = "/patients";
    const URI_PATIENT_INSTANCE = "/patients/{id}";

    public function __construct(PatientService $patientService, EntityManagerInterface $entityManager, PatientMapper $mapper)
    {
        $this->patientService = $patientService;
        $this->entityManager = $entityManager;
        $this->patientMapper = $mapper;
    }

    /**
     * @OA\Get(
     *     path="/patients",
     *     tags={"Patient"},
     *     summary="Returns a list of PatientDTO",
     *     description="Returns a list of PatientDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")   
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no PatientDTO found",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Get(PatientRestController::URI_PATIENT_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $patients = $this->patientService->searchAll();
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($patients){
            return View::create($patients, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create($patients, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/patient/{patientId}",
     *     tags={"Patient"},
     *     summary="Deletes a patient",
     *     description="Deletes a single patient",
     *     operationId="deletePatient",
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="Patient id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Patient not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us.",
     *     )
     * )
     * 
     * @Delete(PatientRestController::URI_PATIENT_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function remove(Patient $patient){
        try{
            $this->patientService->delete($patient);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     tags={"Patient"},
     *     summary="Creates a patient",
     *     description="Creates a patient",
     *     @OA\Response(
     *         response=201,
     *         description="Patient created", 
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO")   
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Post(PatientRestController::URI_PATIENT_COLLECTION)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(PatientDTO $patientDto) {
        try{
            $this->patientService->persist(new Patient(), $patientDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/patient/{patientId}",
     *     tags={"Patient"},
     *     summary="Update a patient",
     *     description="Updates a single patient",
     *     operationId="updatePatient",
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="Patient id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     )
     * )
     * 
     * @Put(PatientRestController::URI_PATIENT_INSTANCE)
     * @ParamConverter("patientDto", converter="fos_rest.request_body")
     * @param PatientDTO $patientDto
     * @return void
     */
    public function update(Patient $patient, PatientDTO $patientDto) {
        try{
            $this->patientService->persist($patient, $patientDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *     path="/patient/{patientId}",
     *     tags={"Patient"},
     *     summary="Find patient by ID",
     *     description="Returns a single patient",
     *     operationId="getPatientById",
     *     @OA\Parameter(
     *         name="patientId",
     *         in="path",
     *         description="ID of patient to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PatientDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     ),
     * )
     * 
     * @Get(PatientRestController::URI_PATIENT_INSTANCE)
     * @return void
     */
    public function searchById(int $id){
        try{
            $patientDto = $this->patientService->searchById($id);
        }catch(PatientServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($patientDto){
            return View::create($patientDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
