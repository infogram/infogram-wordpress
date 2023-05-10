import { __ } from '@wordpress/i18n';
import styled from 'styled-components';

const Embed = styled.div`
	position: absolute;
	opacity: 0;
	width: 100%;
	top: 0;
	left: 0;
	height: 100%;
	background: rgba( 108, 181, 217, 0.6 );
	transition: all 0.4s ease 0s;
	display: flex;
	align-items: center;
	justify-content: center;
`;

const Project = styled.div`
	float: left;
	width: 18%;
	margin: 10px 1%;
	position: relative;
	cursor: pointer;
	overflow: hidden;
	height: 160px;

	&:hover {
		${ Embed } {
			opacity: 1;
		}
	}
`;

const Thumbnail = styled.img`
	width: 100%;
`;

const Title = styled.span`
	position: absolute;
	bottom: 0;
	width: 100%;
	left: 0;
	background: #2d2d2d;
	color: #fff;
	margin: 0;
	padding: 10px 5%;
	font-size: 12px;
	font-weight: 300;
`;

const Add = styled.button`
	border: 2px solid #fff;
	border-radius: 5px;
	display: block;
	width: 130px;
	height: 34px;
	background: none;
	cursor: pointer;
	color: #fff;
	line-height: 30px;
	text-align: center;
	font-size: 13px;
`;

export const Infographic = ( props ) => {
	const { onEmbed, data } = props;
	const { title, thumbnail_url: thumbnailUrl, embed_id: id } = data;

	return (
		<Project>
			<Thumbnail src={ thumbnailUrl } />
			<Title>{ title }</Title>
			<Embed>
				<Add onClick={ () => onEmbed( id, title, thumbnailUrl ) }>
					{ __( 'Embed', 'infogram' ) }
				</Add>
			</Embed>
		</Project>
	);
};
