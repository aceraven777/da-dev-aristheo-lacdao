<?php

namespace Tests\Feature;

use App\Models\TodoItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TodoItemTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->withExceptionHandling();
    }
    
    public function test_can_get_todo_list_items(): void
    {
        TodoItem::factory()->create([
            'description' => 'item 1',
        ]);
        
        TodoItem::factory()->create([
            'description' => 'item 2',
        ]);

        $response = $this->getJson(route('todo-item.index'));

        $json_data = $response->json()['data'];

        $this->assertContains('item 1', $json_data[0]);
        $this->assertContains('item 2', $json_data[1]);
    }
    
    public function test_dont_show_deleted_todo_item(): void
    {
        TodoItem::factory()->create([
            'description' => 'item 1',
        ]);
        
        TodoItem::factory()->create([
            'description' => 'deleted item',
            'deleted_at' => now(),
        ]);

        $response = $this->getJson(route('todo-item.index'));

        $json_data = $response->json()['data'];

        $this->assertContains('item 1', $json_data[0]);
        $this->assertFalse(isset($json_data[1]));
    }
    
    public function test_create_todo_item_no_description(): void
    {
        $post_data = [
            'description' => '',
        ];

        $response = $this->postJson(route('todo-item.store'), $post_data);

        // Make sure no item is inserted in the DB
        $this->assertEmpty(TodoItem::count());

        $response->assertStatus(422);
    }
    
    public function test_create_todo_item_description_exceeds_255_characters(): void
    {
        $post_data = [
            'description' => Str::random(300),
        ];

        $response = $this->postJson(route('todo-item.store'), $post_data);

        // Make sure no item is inserted in the DB
        $this->assertEmpty(TodoItem::count());

        $response->assertStatus(422);
    }
    
    public function test_create_todo_item_valid_description(): void
    {
        $post_data = [
            'description' => Str::random(100),
        ];

        // Make sure todo-items is empty at first
        $this->assertEquals(TodoItem::count(), 0);

        $response = $this->postJson(route('todo-item.store'), $post_data);

        $this->assertEquals(TodoItem::count(), 1);
    }
    
    public function test_delete_invalid_todo_item(): void
    {
        $response = $this->postJson(route('todo-item.destroy', ['id' => 9999]));

        $response->assertStatus(405);
    }
    
    public function test_delete_existing_todo_item(): void
    {
        $todo_item = TodoItem::factory()->create();

        $this->assertEquals(TodoItem::count(), 1);
        $this->assertNull($todo_item->deleted_at);

        $response = $this->deleteJson(route('todo-item.destroy', ['id' => $todo_item->id]));

        $todo_item = $todo_item->fresh();

        $this->assertEquals(TodoItem::count(), 0);
        $this->assertNotNull($todo_item->deleted_at);

        $response->assertStatus(200);
    }
    
    public function test_toggle_todo_item_from_not_completed_to_completed(): void
    {
        $todo_item = TodoItem::factory()->create();

        $this->assertEquals(0, $todo_item->completed);

        $response = $this->postJson(route('todo-item.toggle-completed', ['id' => $todo_item->id]));

        $todo_item = $todo_item->fresh();

        $this->assertEquals(1, $todo_item->completed);
    }
    
    public function test_toggle_todo_item_from_completed_to_not_completed(): void
    {
        $todo_item = TodoItem::factory()->create([
            'completed' => true,
        ]);

        $this->assertEquals(1, $todo_item->completed);

        $response = $this->postJson(route('todo-item.toggle-completed', ['id' => $todo_item->id]));

        $todo_item = $todo_item->fresh();

        $this->assertEquals(0, $todo_item->completed);
    }
}