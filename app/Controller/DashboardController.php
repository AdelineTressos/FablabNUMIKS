<?php
namespace App\Controller;
use App\Repository\UsersRepository;
use App\Repository\ReservationsRepository;
use App\Repository\ConsummablesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function index(UsersRepository $usersRepository, ReservationsRepository $reservationsRepository, ConsummablesRepository $consumableRepository): Response
    {
        $pendingMemberships = $usersRepository->findAllUsersNonValidatedNonVisitors();
        $totalMembers = $usersRepository->countTotalMembers();
        $totalReservations = $reservationsRepository->countTotalReservations();
        $upcomingReservations = $reservationsRepository->findUpcomingReservations();
        $upcomingReservationsInfo = [];
        foreach ($upcomingReservations as $reservation) {
            $eventName = $reservation->getEvent() ? $reservation->getEvent()->getNameEvent() : 'Événement inconnu';
            $workspaceName = $reservation->getWorkspace() ? $reservation->getWorkspace()->getNameWorkspace() : 'Espace inconnu';
            $machineName = $reservation->getMachine() ? $reservation->getMachine()->getNameMachine() : 'Machine inconnue';
            $upcomingReservationsInfo[] = [
                'eventName' => $eventName,
                'workspaceName' => $workspaceName,
                'machineName' => $machineName,
                'startDate' => $reservation->getDateReservation(),
            ];
        }
        $machineUsageStats = $reservationsRepository->countReservationsByMachine();
        $pendingValidations = $reservationsRepository->findPendingValidations();
        $pendingValidationsInfo = [];
        foreach($pendingValidations as $validation){
            $eventName = $validation->getEvent() ? $validation->getEvent()->getNameEvent() : 'Événement inconnu';
            $workspaceName = $validation->getWorkspace() ? $validation->getWorkspace()->getNameWorkspace() : 'Espace inconnu';
            $machineName = $validation->getMachine() ? $validation->getMachine()->getNameMachine() : 'Machine inconnue';
            $pendingValidationsInfo[] = [
                'eventName' => $eventName,
                'workspaceName' => $workspaceName,
                'machineName' => $machineName,
                'startDate' => $validation->getDateReservation(),
            ];
        }
        $consumablesAtThreshold = $consumableRepository->findAtThreshold();
        $endingMembership = $usersRepository->findUsersEndingMembership();

        return $this->render('admin_dashboard/index.html.twig', [
            'pendingMemberships' => $pendingMemberships,
            'totalMembers' => $totalMembers,
            'totalReservations' => $totalReservations,
            'upcomingReservations' => $upcomingReservationsInfo,
            'machineUsageStats' => $machineUsageStats,
            'pendingValidations' => $pendingValidationsInfo,
            'consumablesAtThreshold' => $consumablesAtThreshold,
            'endingMembership' => $endingMembership,
        ]);
    }
}