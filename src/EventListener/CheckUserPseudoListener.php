<?php
namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CheckUserPseudoListener
{
    private UrlGeneratorInterface $urlGenerator;
    private Security $security;

    public function __construct(UrlGeneratorInterface $urlGenerator, Security $security)
    {
        $this->urlGenerator = $urlGenerator;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $user = $this->security->getUser();

        // Skip if the user is not logged in or if the request is for the set_pseudo page
        if (!$user || $request->attributes->get('_route') === 'app_set_pseudo') {
            return;
        }

        // Check if the user has a pseudo
        if (empty($user->getPseudo())) {
            $url = $this->urlGenerator->generate('app_set_pseudo');
            $event->setResponse(new RedirectResponse($url));
        }
    }
}