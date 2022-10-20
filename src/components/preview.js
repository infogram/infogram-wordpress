import logo from '../../button/img/logo.png';
import none from '../../button/img/none.png';
import styled from 'styled-components';

const PreviewContainer = styled.div`
	position: relative;
	border: 1px solid #434343;
	color: #fff;
	display: flex;
	align-items: flex-start;
	padding: 5px;
	min-height: 200px;

	span {
		margin-left: 20px;
	}

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

const Logo = styled.img`
	position: absolute;
	top: 10px;
	right: 10px;
	width: 50px;
	height: auto;
`;

export const Preview = ( props ) => {
	const { id, title, thumbnailUrl } = props;
	const thumbImage = thumbnailUrl ? thumbnailUrl : none;

	return (
		<PreviewContainer>
			<Logo src={ logo } alt="Infogram" />
			<img src={ thumbImage } alt={ title } />
			<span>
				<a
					href={ `https://infogram.com/${ id }` }
					target="_blank"
					rel="noreferrer"
				>
					{ title ? title : 'Infogram' }
				</a>
			</span>
		</PreviewContainer>
	);
};
