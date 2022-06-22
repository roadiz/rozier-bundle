<?php

declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\Controller\CustomForm;

use Doctrine\Persistence\ManagerRegistry;
use RZ\Roadiz\CoreBundle\Entity\CustomForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Themes\Rozier\RozierApp;

final class CustomFormUsageController extends RozierApp
{
    private ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param int $id
     * @return Response
     */
    public function usageAction(int $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ACCESS_CUSTOMFORMS');
        /** @var CustomForm|null customForm */
        $customForm = $this->managerRegistry->getRepository(CustomForm::class)->find($id);

        if ($customForm !== null) {
            $this->assignation['customForm'] = $customForm;
            $this->assignation['usages'] = $customForm->getNodes();

            return $this->render('@RoadizRozier/custom-forms/usage.html.twig', $this->assignation);
        }

        throw new ResourceNotFoundException();
    }
}
