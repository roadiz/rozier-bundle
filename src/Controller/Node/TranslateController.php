<?php

declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\Controller\Node;

use RZ\Roadiz\CoreBundle\Entity\Node;
use RZ\Roadiz\CoreBundle\Entity\Translation;
use RZ\Roadiz\CoreBundle\Exception\EntityAlreadyExistsException;
use RZ\Roadiz\CoreBundle\Node\NodeTranslator;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Themes\Rozier\Forms\Node\TranslateNodeType;
use Themes\Rozier\RozierApp;

class TranslateController extends RozierApp
{
    private NodeTranslator $nodeTranslator;

    /**
     * @param NodeTranslator $nodeTranslator
     */
    public function __construct(NodeTranslator $nodeTranslator)
    {
        $this->nodeTranslator = $nodeTranslator;
    }

    /**
     * @param Request $request
     * @param int $nodeId
     *
     * @return Response
     * @throws \Twig\Error\RuntimeError
     */
    public function translateAction(Request $request, int $nodeId): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ACCESS_NODES');

        /** @var Node|null $node */
        $node = $this->em()->find(Node::class, $nodeId);

        if (null !== $node) {
            $availableTranslations = $this->em()
                ->getRepository(Translation::class)
                ->findUnavailableTranslationsForNode($node);

            if (count($availableTranslations) > 0) {
                $form = $this->createForm(TranslateNodeType::class, null, [
                    'node' => $node,
                ]);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    /** @var Translation $translation */
                    $translation = $form->get('translation')->getData();
                    $translateOffspring = (bool) $form->get('translate_offspring')->getData();

                    try {
                        $this->nodeTranslator->translateNode($translation, $node, $translateOffspring);
                        $this->em()->flush();
                        $msg = $this->getTranslator()->trans('node.%name%.translated', [
                            '%name%' => $node->getNodeName(),
                        ]);
                        $this->publishConfirmMessage($request, $msg, $node->getNodeSources()->first());
                        return $this->redirectToRoute(
                            'nodesEditSourcePage',
                            ['nodeId' => $node->getId(), 'translationId' => $translation->getId()]
                        );
                    } catch (EntityAlreadyExistsException $e) {
                        $form->addError(new FormError($e->getMessage()));
                    }
                }
                $this->assignation['form'] = $form->createView();
            }

            $this->assignation['node'] = $node;
            $this->assignation['translation'] = $this->em()->getRepository(Translation::class)->findDefault();
            $this->assignation['available_translations'] = [];

            foreach ($node->getNodeSources() as $ns) {
                $this->assignation['available_translations'][] = $ns->getTranslation();
            }

            return $this->render('@RoadizRozier/nodes/translate.html.twig', $this->assignation);
        }

        throw new ResourceNotFoundException();
    }
}
