<?php

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;
use App\Repository\WalletRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/wallet')]
class AdminWalletController extends AbstractController
{
    #[Route('/', name: 'app_admin_wallet_index', methods: ['GET'])]
    public function index(WalletRepository $walletRepository): Response
    {
        return $this->render('admin_wallet/index.html.twig', [
            'wallets' => $walletRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_wallet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($wallet);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_wallet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_wallet/new.html.twig', [
            'wallet' => $wallet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_wallet_show', methods: ['GET'])]
    public function show(Wallet $wallet): Response
    {
        return $this->render('admin_wallet/show.html.twig', [
            'wallet' => $wallet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_wallet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Wallet $wallet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_wallet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_wallet/edit.html.twig', [
            'wallet' => $wallet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_wallet_delete', methods: ['POST'])]
    public function delete(Request $request, Wallet $wallet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wallet->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($wallet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_wallet_index', [], Response::HTTP_SEE_OTHER);
    }
}
