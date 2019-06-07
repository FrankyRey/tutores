<?php
// src/EventSubscriber/MenuBuilderSubscriber.php
namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Event\ThemeEvents;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuBuilderSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ThemeEvents::THEME_SIDEBAR_SETUP_MENU => ['onSetupMenu', 100],
        ];
    }
    
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $inicio = new MenuItemModel('home', 'Inicio', 'home', [], 'fas fa-home');
        $solicitud = new MenuItemModel('solicitud','Solicitud','solicitud',[], 'far fa-clipboard');
        $convocatoria = new MenuItemModel('convocatoria','Convocatoria','convocatoria',[], 'far fa-file-pdf');
        $resultados = new MenuItemModel('resultados','Resultados','resultados',[], 'fas fa-search');
        $expedientes = new MenuItemModel('expedientes','Expedientes','expedientes',[], 'fas fa-search');
        
        $event->addItem($inicio);
        $event->addItem($solicitud);
        $event->addItem($convocatoria);
        $event->addItem($resultados);
        $event->addItem($expedientes);

        $this->activateByRoute(
            $event->getRequest()->get('_route'),
            $event->getItems()
        );
    }

    /**
     * @param string $route
     * @param MenuItemModel[] $items
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }
}