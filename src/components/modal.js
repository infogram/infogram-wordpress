import { __ } from '@wordpress/i18n';
import { close } from '@wordpress/icons';
import { Button } from '@wordpress/components';
import styled from 'styled-components';

const CloseIcon = styled( Button )`
	color: #fff;
	position: absolute;
	right: 5px;
	top: 5px;
	z-index: 9;
`;

const Background = styled.div`
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba( 0, 0, 0, 0.2 );
	z-index: 99999;
	font-family: 'Roboto', sans-serif;

	img {
		border: none !important;
		padding: 0 !important;
		height: auto !important;
		max-width: 100% !important;

		&:hover {
			background: none !important;
		}
	}
	a:hover {
		background: none !important;
		img {
			background: none !important;
		}
	}
`;

const ModalContentWrapper = styled.div`
	width: 930px;
	margin: 0 auto;
	background: #434343;
	position: relative;
	top: 50%;
	transform: translateY( -50% );
`;

export const Modal = ( props ) => {
	const { onClose, children } = props;

	return (
		<Background>
			<ModalContentWrapper>
				<CloseIcon
					onClick={ onClose }
					icon={ close }
					label={ __( 'Close', 'infogram' ) }
				/>
				{ children }
			</ModalContentWrapper>
		</Background>
	);
};
