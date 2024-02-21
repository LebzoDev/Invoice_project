<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InvoiceController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }

    #[Route('/new', name: 'create_invoice')]
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


    #[Route('/list', name: 'list')]

    public function list()
    {
        $repository = $this->entityManager->getRepository(Invoice::class);
        $invoices = $repository->findAll();

        // dd($invoices);

        return $this->render('invoice/list.html.twig', [
            'controller_name' => 'InvoiceController',
            'invoices' => $invoices,
        ]);
    }


    #[Route('/edit/{id}', name: 'invoice_edit')]

    public function edit(Invoice $invoice, Request $request, EntityManagerInterface $manager)
    {
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

  
    #[Route('/delete/{id}', name: 'invoice_delete')]

    public function delete(Invoice $invoice, EntityManagerInterface $manager)
    {
        $manager->remove($invoice);
        $manager->flush();

        return $this->redirectToRoute('home');
    }


}
