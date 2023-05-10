export default function Save( { attributes } ) {
	const { id, title } = attributes;
	const shortCodeTitle = title ? `title="${ title }"` : '';

	return `[infogram id="${ id }" ${ shortCodeTitle }]`;
}
