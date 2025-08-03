import React from 'react';
import { Link } from '@inertiajs/react';
import type { LinkLikeComponentProps } from '@shopify/polaris/build/ts/src/utilities/link/types';

/**
 * A wrapper around Inertia Link component that adheres to the LinkLikeComponent interface
 * from Shopify Polaris. This allows Polaris components to use Inertia's client-side navigation.
 */
export const InertiaPolarisLink: React.ComponentType<LinkLikeComponentProps> = ({
    url,
    external,
    target,
    download,
    children,
    ...rest
}) => {
    // If external is true, use a regular anchor tag instead of Inertia Link
    if (external) {
        return (
            <a
                href={url}
                target={target || '_blank'}
                rel="noopener noreferrer"
                download={download}
                {...rest}
            >
                {children}
            </a>
        );
    }

    // For internal links, filter out HTML-specific props that conflict with Inertia Link
    const {
        // Remove HTML anchor-specific props that conflict with Inertia Link
        data,
        form,
        formAction,
        formEncType,
        formMethod,
        formNoValidate,
        formTarget,
        method,
        action,
        encType,
        headers,
        // Remove other potentially conflicting props
        ...inertiaProps
    } = rest;

    // For internal links, use Inertia Link with href prop
    return (
        <Link
            href={url}
            target={target}
            download={download}
            {...(inertiaProps as any)}
        >
            {children}
        </Link>
    );
};

export default InertiaPolarisLink;
