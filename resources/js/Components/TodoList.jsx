import axios from 'axios';
import AddTodoForm from '@/Components/AddTodoForm';
import TodoItemRow from '@/Components/TodoItemRow';
import React, {Component} from 'react'

export default class TodoList extends Component {
	constructor() {
		super();

		this.state = {
            todo_items: [],
        };
	}

    componentDidMount() {
        this.getTodoItems();
     }

    getTodoItems = () => {
        axios.get(route('todo-item.index')).then((response) => {
            this.setState({
                'todo_items': [...response.data.data],
            });
        });
    }

    itemAdded = (item) => {
        this.setState({
            'todo_items': [...this.state.todo_items, ...[item]],
        });
    }

    itemDeleted = (deleted_item) => {
        this.setState({todo_items: this.state.todo_items.filter(function(item) { 
            return item.id !== deleted_item.id;
        })});
    }

    itemToggleCompleted = (updated_item) => {
        this.setState({
            todo_items: this.state.todo_items.map(function(item) { 
                return (item.id === updated_item.id ? updated_item : item)
            })
        });
    }

	render() {
		return (
			<>
                <AddTodoForm itemAdded={this.itemAdded} />

                <div className="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table className="w-full text-sm text-left text-gray-500">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" className="px-6 py-3">
                                    Completed?
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" className="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {this.state.todo_items.map((item, index) => {
                                return (
                                    <TodoItemRow
                                        key={index}
                                        item={item}
                                        itemDeleted={this.itemDeleted}
                                        itemToggleCompleted={this.itemToggleCompleted}
                                    />
                                );
                            })}
                        </tbody>
                    </table>
                </div>
            </>
		);
	}
}