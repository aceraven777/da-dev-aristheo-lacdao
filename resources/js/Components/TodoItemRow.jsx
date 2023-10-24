import axios from 'axios';
import React, {Component} from 'react'
import DangerButton from '@/Components/DangerButton';

export default class TodoItemRow extends Component {
	constructor() {
		super();
	}

    delete = () => {
        axios.delete(route('todo-item.destroy', {id: this.props.item.id})).then((response) => {
            this.props.itemDeleted(this.props.item);
        });
    }

    toggleCompleted = () => {
        axios.post(route('todo-item.toggle-completed', {id: this.props.item.id})).then((response) => {
            this.props.itemToggleCompleted(response.data.data);
        });
    }

	render() {
		return (
			<>
                <tr
                    className={`border-b ${this.props.item.completed ? 'bg-gray-100' : 'bg-white'}`}
                >
                     <td className="px-6 py-4">
                        <input
                            checked={this.props.item.completed}
                            id="checkbox-table-search-1"
                            type="checkbox"
                            onChange={this.toggleCompleted}
                            className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-200 rounded focus:ring-blue-500 focus:ring-2" />
                    </td>
                     <td className={`px-6 py-4 ${this.props.item.completed ? 'line-through' : ''}`}>{this.props.item.description}</td>
                     <td className="px-6 py-4">
                        <DangerButton onClick={this.delete}>
                            DELETE
                        </DangerButton>
                    </td>
                </tr>
            </>
		);
	}
}