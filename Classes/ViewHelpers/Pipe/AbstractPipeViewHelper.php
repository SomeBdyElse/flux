<?php
namespace FluidTYPO3\Flux\ViewHelpers\Pipe;

/*
 * This file is part of the FluidTYPO3/Flux project under GPLv2 or later.
 *
 * For the full copyright and license information, please read the
 * LICENSE.md file that was distributed with this source code.
 */

use FluidTYPO3\Flux\ViewHelpers\AbstractFormViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Class AbstractPipeViewHelper
 */
abstract class AbstractPipeViewHelper extends AbstractFormViewHelper {

	const DIRECTION_IN = 'in';
	const DIRECTION_OUT = 'out';

	/**
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerArgument(
			'direction', 'string',
			'Which endpoint to attach the Pipe to - either "in" or "out". See documentation about Outlets and Pipes',
			FALSE, self::DIRECTION_OUT
		);
	}

	/**
	 * @param array $arguments
	 * @param \Closure $renderChildrenClosure
	 * @param RenderingContextInterface $renderingContext
	 * @return void
	 */
	public static function renderStatic(
		array $arguments,
		\Closure $renderChildrenClosure,
		RenderingContextInterface $renderingContext
	) {
		$form = static::getFormFromRenderingContext($renderingContext);
		$sheet = TRUE === $form->has('pipes') ? $form->get('pipes') : $form->createContainer('Sheet', 'pipes');
		$pipe = static::preparePipeInstance($renderingContext, $arguments);
		foreach ($pipe->getFormFields() as $formField) {
			$sheet->add($formField);
		}
		$form->getOutlet()->addPipeOut($pipe);
	}

	/**
	 * @param RenderingContextInterface $renderingContext
	 * @param array $arguments
	 * @param \Closure $renderChildrenClosure
	 * @return PipeInterface
	 */
	protected static function preparePipeInstance(
		RenderingContextInterface $renderingContext,
		array $arguments,
		\Closure $renderChildrenClosure = NULL
	) {
		return GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager')
			->get('FluidTYPO3\\Flux\\Outlet\\Pipe\\StandardPipe');
	}

}
