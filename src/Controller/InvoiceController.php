<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }

        /**
     * @Route("/new", name="create_invoice")
     */
    public function newInvoice(Request $request, EntityManagerInterface $manager)
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lines = $invoice->getInvoiceLines();
            foreach ($lines as $line) {
                $line->setTotalWithVat((string)($line->getQuantity() * (int) $line->getAmount() + ((int) $line->getVatAmount())));
                $manager->persist($line);
                $line->setInvoice($invoice);
            }
        
            $manager->persist($invoice);
            $manager->flush();

            
            unset($invoice);
            unset($form);

            return $this->redirectToRoute('home');
        }
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/lit", name="list")
     */
    public function list()
    {
        return $this->render('invoice/list.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
    
}
