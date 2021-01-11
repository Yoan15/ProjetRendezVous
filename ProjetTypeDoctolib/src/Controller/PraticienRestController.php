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
     * @Get(PraticienRestController::URI_PRATICIEN_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $praticiens = $this->praticienService->searchAll();
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
