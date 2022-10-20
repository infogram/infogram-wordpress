import { __ } from '@wordpress/i18n';
import { useEffect, useState } from '@wordpress/element';
import { Modal } from './modal';
import { Header } from './header';
import { Infographic } from './infographic';
import { Footer } from './footer';
import { Error } from './error';
import { Spinner } from '@wordpress/components';
import styled from 'styled-components';

const Content = styled.div`
	overflow: hidden;
	outline: none;
	height: 500px;
	display: flex;
	flex-direction: column;
`;

const InfographicsContainer = styled.div`
	overflow-x: hidden;
	max-height: 500px;
`;

const StyledSpinner = styled( Spinner )`
	display: block;
	margin: 0 auto;
	top: 50%;
	transform: translateY( -50% );
`;

export const EmbedModal = ( props ) => {
	const { onClose, onEmbed } = props;

	const [ isLoading, setIsLoading ] = useState( true );
	const [ hasError, setHasError ] = useState( false );
	const [ infographics, setInfographics ] = useState( [] );

	useEffect( () => {
		const data = new FormData(); // eslint-disable-line
		data.append( 'action', 'infogram_projects' );

		const requestOptions = {
			method: 'POST',
			credentials: 'same-origin',
			body: data,
		};

		fetch( ajaxurl, requestOptions ) // eslint-disable-line
			.then( ( response ) => response.json() )
			.then( ( responseData ) => {
				setInfographics( responseData );
			} )
			.catch( () => setHasError( true ) )
			.finally( () => {
				setIsLoading( false );
			} );
	}, [] );

	const hasInfographics = infographics.length > 0;
	const publishedInfographics = infographics.filter(i => i.published);

	return (
		<Modal onClose={ onClose }>
			<Header />
			<Content>
				{ isLoading && <StyledSpinner /> }

				{ ! isLoading && ! hasError && (
					<InfographicsContainer>
						{ hasInfographics ? (
							publishedInfographics.map( ( infographic ) => {
								return (
									<Infographic
										key={ infographic.id }
										data={ infographic }
										onEmbed={ ( id, title, thumbnailUrl ) =>
											onEmbed( id, title, thumbnailUrl )
										}
									/>
								);
							} )
						) : (
							<Error
								message={ __(
									'There are no public infographics for this user.',
									'infogram'
								) }
							/>
						) }
					</InfographicsContainer>
				) }

				{ ! isLoading && hasError && (
					<Error
						message={ __(
							'Could not load data from Infogram. Please check plugin credentials and try again.',
							'infogram'
						) }
					/>
				) }
			</Content>

			<Footer onEmbed={ ( id ) => onEmbed( id ) } />
		</Modal>
	);
};
