<?php declare(strict_types=1);

namespace Symplify\PackageBuilder\Tests\Adapter\Symfony;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symplify\PackageBuilder\Adapter\Symfony\Parameter\ParameterProvider;
use Symplify\PackageBuilder\Neon\NeonLoaderAwareKernelTrait;

final class AppKernel extends Kernel
{
    use NeonLoaderAwareKernelTrait;

    /**
     * @var string
     */
    private $configPath;

    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
        parent::__construct('dev' . random_int(1, 10000), true);
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->configPath);
    }

    protected function build(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->autowire(ParameterProvider::class);
    }
}
