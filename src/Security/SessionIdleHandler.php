<?php
    namespace App\Security;

    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\HttpKernel\Event\GetResponseEvent;
    use Symfony\Component\HttpKernel\HttpKernelInterface;
    use Symfony\Component\Routing\RouterInterface;
    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SessionIdleHandler
{
    protected $session;
    protected $tokenStorage;
    protected $router;
    protected $maxIdleTime;

    public function __construct(
        SessionInterface $session,
        TokenStorageInterface $tokenStorage,
        RouterInterface $router,
        $maxIdleTime = 0
    ) {
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->maxIdleTime = $maxIdleTime;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        if ($this->maxIdleTime > 0) {
            $this->session->start();
            $lapse = time() - $this->session->getMetadataBag()->getLastUsed();
            if ($lapse > $this->maxIdleTime && null !== $this->tokenStorage->getToken()) {
                $this->tokenStorage->setToken(null);
                // Change the route if you are not using FOSUserBundle.
                $event->setResponse(new RedirectResponse($this->router->generate('page_home')));
            }
        }
    }
}
