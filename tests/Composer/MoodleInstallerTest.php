<?php

namespace Moodle\Composer\Test;

use Composer\Repository\ArrayRepository;
use Moodle\Composer\MoodleInstaller;

class MoodleInstallerTest extends TestCase
{
    /**
     * @dataProvider moodleInstallDataProvider
     * @param array<string, mixed> $rootExtras
     * @param array<string, mixed> $moodleExtras
     */
    public function testInstallPath(
        string $expectedPublic,
        string $expectedRootPath,
        string $expectedName,
        string $expectedInstallPath,
        string $composerType,
        array $rootExtras,
        array $moodleExtras,
        string $packageName,
    ): void {
        $composer = $this->getComposer();
        $composer->getPackage()->setExtra($rootExtras);

        // Add the Moodle package to the repository manager.
        $repository = new ArrayRepository();
        $moodlePackage = $this->getPackage('moodle/moodle', '1.0.0');
        $moodlePackage->setExtra($moodleExtras);
        $repository->addPackage($moodlePackage);
        $composer->getRepositoryManager()->addRepository($repository);

        // Create the installer.
        $testPackage = $this->getPackage($packageName, '1.0.0');
        $testPackage->setType($composerType);
        $installer = new MoodleInstaller(
            $this->getMockIO(),
            $composer,
        );

        $result = $installer->getTemplateVars($testPackage);

        $this->assertEquals($result['public'], $expectedPublic);
        $this->assertEquals($result['prefix'], $expectedRootPath);
        $this->assertEquals($result['name'], $expectedName);
        $this->assertEquals($expectedInstallPath, $installer->getInstallPath($testPackage));
    }

    public static function moodleInstallDataProvider(): array
    {
        return [
            // Legacy install without public dir.
            [
                '', // expected public path
                '', // expected install path
                'custommod', // expected name
                'mod/custommod/', // expected install path
                'moodle-mod', // composer type
                [], // root extras
                [],  // package extras
                'moodle-mod_custommod', // package name
            ],

            // Modern install moodle/moodle.
            [
                '', // expected public path
                'moodle/', // expected install path
                'moodle', // expected name
                'moodle/', // expected install path
                'moodle-core', // composer type
                ['install-path' => 'moodle/'], // root extras
                [],  // package extras
                'moodle', // package name
            ],
            // Modern install with public dir and install path.
            [
                'public/', // expected public path
                'moodle/', // expected install path
                'customblock', // expected name
                'moodle/public/blocks/customblock/', // expected install path
                'moodle-block', // composer type
                ['install-path' => 'moodle/'], // root extras
                ['haspublicdir' => true],  // package extras
                'moodle-block_customblock', // package name
            ],

            // Modern install with public dir and no install path.
            [
                'public/', // expected public path
                '', // expected install path
                'customblock', // expected name
                'public/blocks/customblock/', // expected install path
                'moodle-block', // composer type
                [], // root extras
                ['haspublicdir' => true],  // package extras
                'moodle-block_customblock', // package name
            ],
        ];
    }
}
