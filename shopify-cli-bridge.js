import fs from 'fs';
import path from 'path';

// Capture all Shopify environment variables in an object
const shopifyEnvVars = {
    // Core Shopify Variables
    SHOPIFY_API_KEY: process.env.SHOPIFY_API_KEY || '',
    SHOPIFY_API_SECRET: process.env.SHOPIFY_API_SECRET || '',
    SCOPES: process.env.SCOPES || '',
    HOST: process.env.HOST || '',

    // Development Environment Variables
    NODE_ENV: process.env.NODE_ENV || '',
    APP_ENV: process.env.APP_ENV || '',
    APP_URL: process.env.APP_URL || '',

    // Port Configuration
    PORT: process.env.PORT || '',
    SERVER_PORT: process.env.SERVER_PORT || '',
    BACKEND_PORT: process.env.BACKEND_PORT || '',
    FRONTEND_PORT: process.env.FRONTEND_PORT || '',
    HMR_SERVER_PORT: process.env.HMR_SERVER_PORT || '',

    // Additional Variables
    SHOP_CUSTOM_DOMAIN: process.env.SHOP_CUSTOM_DOMAIN || '',
    REMIX_DEV_ORIGIN: process.env.REMIX_DEV_ORIGIN || ''
};

// Check if SHOPIFY_API_SECRET is empty and exit with non-zero status if so
if (!shopifyEnvVars.SHOPIFY_API_SECRET) {
    console.error("ERROR: SHOPIFY_API_SECRET is not passed along by Shopify CLI.");
    process.exit(1);
}

// Write SHOPIFY_API_SECRET to .env file
const envPath = path.join(process.cwd(), '.env');
const envExamplePath = path.join(process.cwd(), '.env.example');
let envContent = '';

// Check if .env file exists
if (fs.existsSync(envPath)) {
    // Read existing .env file
    envContent = fs.readFileSync(envPath, 'utf8');
} else {
    // If .env doesn't exist, create it using .env.example content
    if (fs.existsSync(envExamplePath)) {
        envContent = fs.readFileSync(envExamplePath, 'utf8');
        console.log('INFO: .env file not found, creating from .env.example template');
    } else {
        console.log('WARNING: Neither .env nor .env.example found, creating empty .env file');
    }
}

// Check if SHOPIFY_API_SECRET already exists in .env file
const secretRegex = /^SHOPIFY_API_SECRET=.*$/m;
if (secretRegex.test(envContent)) {
    // Update existing SHOPIFY_API_SECRET while ensuring proper spacing
    const lines = envContent.split('\n');
    let secretLineIndex = lines.findIndex(line => line.match(/^SHOPIFY_API_SECRET=/));

    // Ensure blank line above SHOPIFY_API_SECRET
    if (secretLineIndex > 0 && lines[secretLineIndex - 1].trim() !== '') {
        lines.splice(secretLineIndex, 0, '');
        secretLineIndex++;
    }

    // Update the SHOPIFY_API_SECRET line
    lines[secretLineIndex] = `SHOPIFY_API_SECRET=${shopifyEnvVars.SHOPIFY_API_SECRET}`;

    // Ensure blank line below SHOPIFY_API_SECRET
    if (secretLineIndex < lines.length - 1 && lines[secretLineIndex + 1].trim() !== '') {
        lines.splice(secretLineIndex + 1, 0, '');
    }

    envContent = lines.join('\n');
} else {
    // Add SHOPIFY_API_SECRET to the end of the file with proper spacing
    if (envContent && !envContent.endsWith('\n')) {
        envContent += '\n';
    }
    envContent += '\n';
    envContent += `SHOPIFY_API_SECRET=${shopifyEnvVars.SHOPIFY_API_SECRET}`;
    envContent += '\n';
}

// Write the updated content back to .env file
fs.writeFileSync(envPath, envContent);
console.log(`\nSUCCESS: SHOPIFY_API_SECRET has been written to .env file`);
