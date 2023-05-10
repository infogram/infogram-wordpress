import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import styled, { css } from 'styled-components';
import { Button } from '@wordpress/components';

const FAQLink = styled.a`
	color: #3796c9;
	font-size: 13px;
	font-weight: 500;
	margin-top: 12px;
	text-decoration: none;

	&:hover {
		text-decoration: underline;
	}
`;

const Submit = styled( Button )`
	position: absolute;
	top: 4px;
	right: 2px;
	border-radius: 5px;
	background: #3796c9;
	color: #fff;
	font-weight: 700;
	/* important to override WP admin styles */
	padding: 7px 35px !important;
	border: 0;
	font-family: 'Roboto', sans-serif;
	font-weight: 500;
	font-size: 13px;
	transition: all 0.4s ease 0s;
	line-height: 1.3;

	&:hover,
	&:active {
		background: #5fb7e5;
		/* important to override WP admin styles */
		color: #fff !important;
	}
`;

const ErrorMsg = styled.div`
	font-size: 11px;
	display: block;
	color: #fff;
	clear: both;
	max-width: 100%;
	text-align: left;
	margin: 0;
`;

const InputWrapper = styled.div`
	position: relative;
	display: flex;
	flex-direction: column;
	width: 700px;
	height: 62px;
`;

const StyledInput = styled.input`
	width: 100%;
	color: #434343;
	border-radius: 5px;
	padding: 10px 20px;
	font-size: 15px;
	font-family: 'Roboto', sans-serif;
	font-weight: 500;
	line-height: 1.3;
	border: 2px solid #fff;

	${ ( props ) =>
		props.error &&
		css`
			border: 2px solid #c32f2f;
			color: #c32f2f;
		` }
`;

const FooterContent = styled.div`
	background: #2c2b2b;
	padding: 20px 2% 0;
	display: flex;
	justify-content: space-between;
`;

export const Footer = ( props ) => {
	const { onEmbed } = props;
	const [ errorVisible, setErrorVisible ] = useState( false );
	const [ inputValue, setInputValue ] = useState( '' );

	const extractId = () => {
		setErrorVisible( false );

		let link = inputValue;
		const check = [
			'https://infogram.com/',
			'https://e.infogram.com/',
			'?src=embed',
			'/',
		];

		if ( ! link ) {
			return;
		}

		if ( link.indexOf( check[ 0 ] ) + 1 ) {
			link = link.replace( check[ 0 ], '' );
			if ( link.indexOf( check[ 3 ] ) + 1 ) {
				setErrorVisible( true );
				return;
			}
		} else if ( link.indexOf( check[ 1 ] ) + 1 ) {
			if ( link.indexOf( check[ 2 ] ) + 1 ) {
				link = link.replace( check[ 1 ], '' );
				link = link.replace( check[ 2 ], '' );
			} else {
				link = link.replace( check[ 1 ], '' );
			}
			if ( link.indexOf( check[ 3 ] ) + 1 ) {
				setErrorVisible( true );
				return;
			}
		} else {
			setErrorVisible( true );
			return;
		}

		onEmbed( link );
	};

	return (
		<FooterContent>
			<FAQLink
				href="https://support.infogram.com/hc/en-us/articles/360000583174-Using-Infogram-in-WordPress"
				target="_blank"
			>
				{ __( 'Need help with plugin?', 'infogram' ) }
			</FAQLink>

			<InputWrapper>
				<StyledInput
					value={ inputValue }
					error={ errorVisible }
					onChange={ ( e ) => setInputValue( e.target.value ) }
					placeholder={ __(
						'Embed from a link. Paste the Infogram.com URL to the chart or infographic here.',
						'infogram'
					) }
				/>
				<Submit type="submit" onClick={ extractId }>
					{ __( 'Embed', 'infogram' ) }
				</Submit>

				{ errorVisible && (
					<ErrorMsg>
						{ __(
							'Please use a valid infogram.com URL that contains an infographic.',
							'infogram'
						) }
					</ErrorMsg>
				) }
			</InputWrapper>
		</FooterContent>
	);
};
