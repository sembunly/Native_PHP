<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class MemberTest extends TestCase
{
    public function testMemberRequiredFieldsArePresentInSchema(): void
    {
        $schema = file_get_contents(dirname(__DIR__) . '/database/migrations/002_create_members.sql');
        self::assertStringContainsString('first_name', $schema);
        self::assertStringContainsString('email', $schema);
        self::assertStringContainsString('status', $schema);
    }
}
