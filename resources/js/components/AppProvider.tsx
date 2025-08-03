import {
    AppProvider as PolarisAppProvider,
    AppProviderProps as PolarisAppProviderProps,
} from '@shopify/polaris';
import englishI18n from '@shopify/polaris/locales/en.json' with {type: 'json'};
import { InertiaPolarisLink } from './InertiaPolarisLink';

interface AppProviderProps extends Omit<PolarisAppProviderProps, 'i18n'> {
    i18n?: PolarisAppProviderProps['i18n'];
}

export function AppProvider(props: AppProviderProps) {
    const {
        children,
        i18n,
        ...polarisProps
    } = props;

    return (
        <>
            <PolarisAppProvider
                {...polarisProps}
                linkComponent={InertiaPolarisLink}
                i18n={i18n || englishI18n}
            >
                {children}
            </PolarisAppProvider>
        </>
    );
}
