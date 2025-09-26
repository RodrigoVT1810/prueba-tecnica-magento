<?php
namespace PTRVT\Blog\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InitHelloWorld implements DataPatchInterface
{
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public function apply()
    {
        $logFile = BP . '/var/log/patch_test.log';
        file_put_contents($logFile, "➡️ Iniciando apply() de InitHelloWorld\n", FILE_APPEND);

        try {
            $this->moduleDataSetup->getConnection()->startSetup();

            $this->moduleDataSetup->getConnection()->insert(
                $this->moduleDataSetup->getTable('ptrvt_blog_post'),
                [
                    'title'      => 'Hello World',
                    'content'    => 'Este es un test',
                    'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
                ]
            );

            file_put_contents($logFile, "✅ Insert exitoso en ptrvt_blog_post\n", FILE_APPEND);

            $this->moduleDataSetup->getConnection()->endSetup();
        } catch (\Exception $e) {
            file_put_contents(
                $logFile,
                "❌ Error en InitHelloWorld: " . $e->getMessage() . "\n",
                FILE_APPEND
            );
            throw $e; // re-lanzamos por si Magento necesita marcar fallo
        }
    }

    public static function getDependencies() { return []; }
    public function getAliases() { return []; }
}