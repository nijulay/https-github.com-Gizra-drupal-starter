<?php

namespace Drupal\Tests\server_general\ExistingSite;

use weitzman\DrupalTestTraits\ExistingSiteBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\node\NodeInterface;
use Drupal\og\Entity\OgMembershipType;
use Drupal\og\Entity\OgRole;
use Drupal\og\Og;
use Drupal\og\OgMembershipInterface;
use Drupal\og\OgRoleInterface;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\og\Traits\OgMembershipCreationTrait;

/**
 * A model test case using traits from Drupal Test Traits.
 */
class ServerGeneralCreateGroupblog extends ExistingSiteBase {

  /**
   * An example test method; note that Drupal API's and Mink are available.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   * @throws \Drupal\Core\Entity\EntityMalformedException
   * @throws \Behat\Mink\Exception\ExpectationException
   */
  public function testGroupblog() {
    // Creates a user. Will be automatically cleaned up at the end of the test.
    $author = $this->createUser();

    // Create a "Test Group Node" group_blog. Will be automatically cleaned up at end of
    // test.
    $node = $this->createNode([
      'title' => 'Test Group Node',
      'type' => 'group_blog',
      'field_tags' => [
        'target_id' => $term->id(),
      ],
      'uid' => $author->id(),
    ]);
    $this->assertEquals($author->id(), $node->getOwnerId());

    // We can browse pages.
    $this->drupalGet($node->toUrl());
    $this->assertSession()->statusCodeEquals(200);

    // We can login and browse admin pages.
    $this->drupalLogin($author);
    $this->drupalGet($node->toUrl('edit-form'));
  }

}
