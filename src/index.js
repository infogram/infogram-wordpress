import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import Save from './save';

registerBlockType( 'infogram/infogram', {
	title: 'Infogram',
	name: 'infogram/infogram',
	icon: 'flag',
	example: {
		attributes: {
			message: 'Infogram',
		},
	},
	apiVersion: 2,
	version: '0.1.0',
	category: 'text',
	description: 'It allows you to insert graphics from the site infogram.com',
	textdomain: 'infogram',
	edit: Edit,
	save: Save,
} );
