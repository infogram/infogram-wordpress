import { __ } from '@wordpress/i18n';
import { BlockControls } from '@wordpress/block-editor';
import { ToolbarButton } from '@wordpress/components';
import { edit } from '@wordpress/icons';

export const EditToolbar = ( props ) => {
	const { onEditClick } = props;

	return (
		<BlockControls>
			<ToolbarButton
				onClick={ onEditClick }
				icon={ edit }
				label={ __( 'Edit', 'infogram' ) }
			/>
		</BlockControls>
	);
};
