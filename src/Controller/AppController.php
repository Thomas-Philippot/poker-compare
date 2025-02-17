<?php

namespace App\Controller;

use App\Entity\PokerHand;
use App\Exception\DuplicatedCardsException;
use App\Exception\InvalidCardListException;
use App\Form\Type\PokerTableType;
use App\Service\PokerTableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{

    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(PokerTableType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('app_result', [
                'firstHand' => $data['firstPlayer'],
                'secondHand' => $data['secondPlayer'],
            ]);

        }
        return $this->render('pages/index.html.twig',[
            'form' => $form,
        ]);
    }

    #[Route('/result', name: 'app_result')]
    public function displayResult(
        #[MapQueryParameter] string $firstHand,
        #[MapQueryParameter] string $secondHand,
        PokerTableService $service
    ): Response
    {
        $result = "";
        try {
            $service->init($firstHand, $secondHand);
            switch ($service->play()) {
                case 1:
                    $result = "Player 1 wins";
                    break;
                case 2:
                    $result = "Player 2 wins";
                    break;
                case 3:
                    $result = "Tie";
                    break;
            }

        } catch (InvalidCardListException | DuplicatedCardsException $e) {
            $this->addFlash('error', $e->getMessage());
        }
        return $this->render('pages/results.html.twig', ['result' => $result]);
    }

}