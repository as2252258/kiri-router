<?php
declare(strict_types=1);

namespace Kiri\Router\Aspect;

interface OnAspectInterface
{


	/**
	 * @param OnJoinPointInterface $joinPoint
	 * @return mixed
	 */
	public function process(OnJoinPointInterface $joinPoint): mixed;


}
