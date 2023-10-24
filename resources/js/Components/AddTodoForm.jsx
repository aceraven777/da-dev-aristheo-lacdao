import axios from 'axios';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import PrimaryButton from '@/Components/PrimaryButton';
import React, {Component} from 'react'

export default class AddTodoForm extends Component {
	constructor() {
		super();

		this.state = {
            description: '',
        };
	}

    descriptionChanged = (e) => {
        this.setState({
            'description': e.target.value
        });
    }

    addTodo = (e) => {
        e.preventDefault();

        axios.post(route('todo-item.store'), {
            description: this.state.description,
        }).then((response) => {
            this.setState({
                'description': ''
            });

            this.props.itemAdded(response.data.data); 
        });
    }

	render() {
		return (
			<>
                <form className="sm:flex sm:justify-center sm:items-center" onSubmit={this.addTodo}>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 items-end">
                        <div>
                            <InputLabel htmlFor="todo-description">
                                Add Todo Item
                            </InputLabel>
                            <TextInput
                                id="todo-description"
                                name="description"
                                maxLength="255"
                                required
                                onChange={this.descriptionChanged}
                                value={this.state.description}
                            />
                        </div>

                        <div>
                            <PrimaryButton type="submit">Add</PrimaryButton>
                        </div>
                    </div>
                </form>                
            </>
		);
	}
}