<?php

namespace App\Controller;

use App\DTO\PraticienDTO;
use App\Entity\Praticien;
use FOS\RestBundle\View\View;
use App\Mapper\PraticienMapper;
use App\Service\PraticienService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\PraticienServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use App\Repository\PraticienRepository;

class PraticienRestController extends AbstractFOSRestController
{
    private $praticienService;

    const URI_PRATICIEN_COLLECTION = "/praticiens";
    const URI_PRATICIEN_INSTANCE = "/praticiens/{id}";

    public function __construct(PraticienService $praticienService, EntityManagerInterface $entityManager, PraticienMapper $mapper)
    {
        $this->praticienService = $praticienService;
        $this->entityManager = $entityManager;
        $this->praticienMapper = $mapper;
    }

    /**
     * @OA\Get(
     *     path="/praticiens",
     *     tags={"Praticien"},
     *     summary="Returns a list of PraticienDTO",
     *     description="Returns a list of PraticienDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/PraticienDTO")   
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no PraticienDTO found",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Get(PraticienRestController::URI_PRATICIEN_COLLECTION)
     * @QueryParam(
     * name="specialite",
     * key="specialite",
     * requirements="\w+",
     * default="null")
     */
    public function searchAll(string $specialite)
    {
        try{
            if ($specialite != "null") {
                $praticiens = $this->praticienService->searchBySpe($specialite);
            }else{
                $praticiens = $this->praticienService->searchAll();
            }
        }catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($praticiens){
            return View::create($praticiens, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create($praticiens, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/praticien/{praticienId}",
     *     tags={"Praticien"},
     *     summary="Deletes a praticien",
     *     description="Deletes a single praticien",
     *     operationId="deletePraticien",
     *     @OA\Parameter(
     *         name="praticienId",
     *         in="path",
     *         description="Praticien id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Praticien not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us.",
     *     )
     * )
     * 
     * @Delete(PraticienRestController::URI_PRATICIEN_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function remove(Praticien $praticien){
        try{
            $this->praticienService->delete($praticien);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        }catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/praticiens",
     *     tags={"Praticien"},
     *     summary="Creates a praticien",
     *     description="Creates a praticien",
     *     @OA\Response(
     *         response=201,
     *         description="Praticien created", 
     *         @OA\JsonContent(ref="#/components/schemas/PraticienDTO")   
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Post(PraticienRestController::URI_PRATICIEN_COLLECTION)
     * @ParamConverter("praticienDto", converter="fos_rest.request_body")
     * @return void
    */
    public function create(PraticienDTO $praticienDto){
        try{
            $this->praticienService->persist(new Praticien(), $praticienDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        }catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/praticien/{praticienId}",
     *     tags={"Praticien"},
     *     summary="Update a praticien",
     *     description="Updates a single praticien",
     *     operationId="updatePraticien",
     *     @OA\Parameter(
     *         name="praticienId",
     *         in="path",
     *         description="Praticien id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Praticien updated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     )
     * )
     * 
     * @Put(PraticienRestController::URI_PRATICIEN_INSTANCE)
     * @ParamConverter("praticienDto", converter="fos_rest.request_body")
     * @param PraticienDTO $praticienDto
     * @return void
     */
    public function update(Praticien $praticien, PraticienDTO $praticienDto){
        try{
            $this->praticienService->persist($praticien, $praticienDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        }catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *     path="/praticien/{praticienId}",
     *     tags={"Praticien"},
     *     summary="Find praticien by ID",
     *     description="Returns a single praticien",
     *     operationId="getPraticienById",
     *     @OA\Parameter(
     *         name="praticienId",
     *         in="path",
     *         description="ID of praticien to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/PraticienDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Praticien not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     ),
     * )
     * 
     * @Get(PraticienRestController::URI_PRATICIEN_INSTANCE)
     * @return void
     */
    public function searchById(int $id){
        try{
            $praticienDto = $this->praticienService->searchById($id);
        }catch(PraticienServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($praticienDto){
            return View::create($praticienDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
