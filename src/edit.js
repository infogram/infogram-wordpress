import { useState } from '@wordpress/element';
import { useBlockProps } from '@wordpress/block-editor';
import { PreviewModal } from './components/preview-modal';
import { EmbedModal } from './components/embed-modal';
import { EditToolbar } from './components/edit-toolbar';
import { Preview } from './components/preview';

export default function Edit( { attributes, setAttributes } ) {
	const { id, title, thumbnailUrl } = attributes;

	const blockProps = useBlockProps();
	const [ embedModalVisible, setEmbedModalVisible ] = useState( false );
	const [ previewModalVisible, setPreviewModalVisible ] = useState( false );

	return (
		<div { ...blockProps }>
			<Preview id={ id } title={ title } thumbnailUrl={ thumbnailUrl } />

			<EditToolbar
				onEditClick={ () =>
					attributes.configured
						? setEmbedModalVisible( true )
						: setPreviewModalVisible( true )
				}
			/>

			{ embedModalVisible && (
				<EmbedModal
					onClose={ () => setEmbedModalVisible( false ) }
					onEmbed={ ( id, title, thumbnailUrl ) => {
						setEmbedModalVisible( false );
						setAttributes( {
							id,
							title,
							thumbnailUrl,
						} );
					} }
				/>
			) }

			{ previewModalVisible && (
				<PreviewModal
					bloginfo={ attributes.bloginfo }
					onClose={ () => setPreviewModalVisible( false ) }
				/>
			) }
		</div>
	);
}
