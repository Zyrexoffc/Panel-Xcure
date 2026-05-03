import React, { useState, useEffect } from 'react';
import useSWR from 'swr';
import http from '@/api/http';
import FlashMessageRender from '@/components/FlashMessageRender';
import { Button } from '@/components/elements/button/Button';
/* blueprint/import */

interface PanelProtectData {
    panel_protect: boolean;
}

export default () => {
    const { data, mutate } = useSWR<PanelProtectData>('/api/client/account/panel-protect', key =>
        http.get(key).then(res => res.data)
    );
    const [loading, setLoading] = useState(false);
    const [message, setMessage] = useState('');

    const toggleProtect = async () => {
        setLoading(true);
        setMessage('');
        try {
            const res = await http.post('/api/client/account/panel-protect/toggle');
            mutate();
            setMessage(res.data.message || 'Success');
        } catch (e: any) {
            setMessage(e.response?.data?.message || 'Error');
        } finally {
            setLoading(false);
        }
    };

    return (
        <>
            <div className="bg-zinc-800 rounded-lg p-6 mt-6 border border-zinc-700">
                <h3 className="text-lg font-bold text-white mb-2">
                    Panel Protect <span className="text-sm text-zinc-400">by Zyrex Official</span>
                </h3>
                <p className="text-sm text-zinc-300 mb-4">
                    Panel Protect prevents administrators from accessing your server panel. 
                    When enabled, anyone with admin privileges attempting to view your server 
                    or account will see a warning page instead of the actual content.
                </p>
                <div className="flex items-center justify-between">
                    <div className="flex items-center space-x-3">
                        <button
                            onClick={toggleProtect}
                            disabled={loading}
                            className={`relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 ${
                                data?.panel_protect ? 'bg-blue-600' : 'bg-zinc-600'
                            }`}
                        >
                            <span
                                className={`inline-block h-4 w-4 transform rounded-full bg-white transition-transform ${
                                    data?.panel_protect ? 'translate-x-6' : 'translate-x-1'
                                }`}
                            />
                        </button>
                        <span className="text-sm text-zinc-300">
                            {data?.panel_protect ? 'ENABLED' : 'DISABLED'}
                        </span>
                    </div>
                    {loading && <span className="text-xs text-zinc-400">Loading...</span>}
                </div>
                {message && (
                    <div className={`mt-3 text-sm ${message.includes('Success') ? 'text-green-400' : 'text-red-400'}`}>
                        {message}
                    </div>
                )}
                <div className="mt-4 text-xs text-zinc-500 text-right">
                    by Zyrex Official
                </div>
            </div>
            {/* blueprint/react */}
        </>
    );
};
