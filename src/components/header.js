import { __ } from '@wordpress/i18n';
import styled from 'styled-components';
import logow from '../../button/img/logow.png';

const Background = styled.div`
	z-index: 1;
	background: #3b3b3b;
	font-size: 15px;
	color: #fff;
	line-height: 1.5;
	font-weight: 500;
	padding: 20px 5% 5px 2%;
`;

const Content = styled.div`
	width: 100%;
	display: flex;
	justify-content: space-between;
`;

const InfogramLogo = styled.a`
	display: block;
`;

const StyledSpan = styled.span`
	margin: 0;
	color: #fff;
`;

export const Header = () => (
	<Background>
		<Content>
			<StyledSpan>
				{ __( 'Click on a chart or infographic to embed', 'infogram' ) }
			</StyledSpan>
			<InfogramLogo
				href="https://infogram.com/"
				target="_blank"
				title="Infogram"
			>
				<img src={ logow } alt="Infogram" />
			</InfogramLogo>
		</Content>
	</Background>
);
