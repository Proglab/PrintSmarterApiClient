<?php

namespace Proglab\PrintSmarterApiClient\Controller;

use Proglab\PrintSmarterApiClient\Dto\Order;
use Proglab\PrintSmarterApiClient\Dto\Product;
use Proglab\PrintSmarterApiClient\Error\PrintSmarterApiException;
use Proglab\PrintSmarterApiClient\Form\OrderType;
use Proglab\PrintSmarterApiClient\Service\PrintSmarterApiClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/print-smarter', name: 'print_smarter_')]
class OrderController extends AbstractController
{
    #[Route('/order/new', name: 'order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PrintSmarterApiClient $apiClient): Response
    {
        $order = new Order();
        // Ajouter un produit vide par défaut
        $order->products[] = new Product();

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {


                dd($order);



                $result = $apiClient->addOrder($order);

                return $this->render('@PrintSmarterApiClient/order/success.html.twig', [

                    'result' => $result,
                    'order'  => $order,
                ]);
            } catch (PrintSmarterApiException $e) {
                $this->addFlash('danger', sprintf(
                    'Erreur API PrintSmarter (%d) : %s',
                    $e->getCode(),
                    $e->getMessage()
                ));
            }
        }

        return $this->render('@PrintSmarterApiClient/order/new.html.twig', [
            'form' => $form,
        ]);
    }
}


