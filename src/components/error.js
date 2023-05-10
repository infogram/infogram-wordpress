import styled from 'styled-components';

const ErrorContainer = styled.div`
	font-size: 11px;
	display: block;
	color: #fff;
	clear: both;
	max-width: 100%;
	text-align: left;
	margin: 0;
	padding: 20px 5% 5px 2%;
`;

export const Error = ( props ) => {
	const { message } = props;

	return (
		<ErrorContainer>
			<p>
				<strong>{ message }</strong>
			</p>
		</ErrorContainer>
	);
};
