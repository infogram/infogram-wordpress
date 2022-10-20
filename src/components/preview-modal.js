import { __ } from '@wordpress/i18n';
import { Modal } from './modal';
import image1 from '../../button/img/slide1.gif';
import image2 from '../../button/img/slide2.gif';
import image3 from '../../button/img/slide3.gif';
import image4 from '../../button/img/slide4.gif';
import logo from '../../button/img/logo.png';
import styled from 'styled-components';

const InfoArea = styled.div`
	padding: 70px 40px 100px;
	background: #8ec3a7;
	width: 520px;
`;

const Content = styled.div`
	display: flex;
`;

const Title = styled.h1`
	font-size: 37px;
	color: #fff;
	font-weight: 300;
	line-height: 1.4;
	margin: 0 0 10px 0;
`;

const StyledLink = styled.a`
	color: #2f6857;
	text-decoration: none;
`;

const StyledSpan = styled.span`
	font-size: 15px;
	color: #fff;
	line-height: 1.5;
	font-weight: 500;

	${ StyledLink } {
		&:hover {
			text-decoration: underline;
		}
	}
`;

const StyledSettingsSpan = styled.span`
	color: #fff;
	text-align: left;
	margin-bottom: 5px;
	font-size: 15px;
	font-weight: 500;
	display: block;
`;

const Slides = styled.div`
	margin-top: 50px;

	img {
		margin-right: 16px;
	}
`;

const SettingsArea = styled.div`
	padding: 70px 40px 100px;
	background: #434343;
	width: 290px;
	text-align: center;
	vertical-align: top;
`;

const CreateAccLink = styled.a`
	border-radius: 5px;
	background: #3796c9;
	color: #fff !important;
	display: block;
	text-align: center;
	text-decoration: none;
	font-size: 17px;
	line-height: 50px;
	width: 100%;
	margin: 15px 0 25px;
	transition: all 0.4s ease 0s;

	&:hover {
		background: #5fb7e5;
		color: #fff;
	}
`;

const GoToSettongsLink = styled.a`
	border-radius: 5px;
	border: 2px solid #fff;
	color: #fff !important;
	display: block;
	margin: 15px 0;
	text-align: center;
	text-decoration: none;
	font-size: 17px;
	line-height: 36px;
	width: 100%;
	transition: all 0.4s ease 0s;

	&:hover {
		background: #fff;
		color: #000;
	}
`;

const SettingsAreaButtons = styled.div`
	margin-top: 50px;
`;

export const PreviewModal = ( props ) => {
	const { onClose, bloginfo } = props;

	return (
		<Modal onClose={ onClose }>
			<Content>
				<InfoArea>
					<Title>
						{ __(
							'Embed interactive charts and infographics',
							'infogram'
						) }
					</Title>

					<StyledSpan>
						{ __(
							'Infogram.com lets you quickly and easily create interactive and responsive data visualizations.',
							'infogram'
						) }
						<StyledLink
							href="https://infogram.com/"
							target="_blank"
							rel="noreferrer"
						>
							{ __( 'Read more', 'infogram' ) }.
						</StyledLink>
					</StyledSpan>

					<Slides>
						<img src={ image1 } alt="Infogram" />
						<img src={ image2 } alt="Infogram" />
						<img src={ image3 } alt="Infogram" />
						<img src={ image4 } alt="Infogram" />
					</Slides>
				</InfoArea>

				<SettingsArea>
					<a
						href="https://infogram.com/"
						target="_blank"
						title="Ingfogram"
						rel="noreferrer"
					>
						<img src={ logo } alt="Infogram" />
					</a>
					<SettingsAreaButtons>
						<StyledSettingsSpan>
							{ __(
								'Not yet an Infogram.com user?',
								'infogram'
							) }
						</StyledSettingsSpan>
						<CreateAccLink
							target="_blank"
							title={ __( 'Create an account.', 'infogram' ) }
							href="https://infogram.com/?utm_source=wp-plugin&utm_medium=wp&utm_campaign=wp"
						>
							{ __( 'Create new account', 'infogram' ) }
						</CreateAccLink>
					</SettingsAreaButtons>

					<div>
						<StyledSettingsSpan>
							{ __(
								'Already have an Infogram.com account?',
								'infogram'
							) }
						</StyledSettingsSpan>
						<GoToSettongsLink
							target="_blank"
							title={ __( 'Authenticate here', 'infogram' ) }
							href={ `${ bloginfo }/wp-admin/options-general.php?page=infogram` }
						>
							{ __( 'Authenticate here', 'infogram' ) }
						</GoToSettongsLink>
					</div>
				</SettingsArea>
			</Content>
		</Modal>
	);
};
