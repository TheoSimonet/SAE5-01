import React, {useState, useEffect} from 'react';
import {getGroup} from '../services/api';
import {useRoute} from 'wouter';

function Group() {
    const [group, setGroup] = useState(null);
    const [, params] = useRoute('/react/groups/:id');

    useEffect(() => {
        getGroup(params.id).then((data) => {
            setGroup(data);
        });
    }, [params.id]);

    return (
        <div>
            {group === null ? 'Loading...' : (
                <div>
                    <h1>{group.lib}</h1>
                    <p>type : {group.type}</p>
                </div>
            )}
        </div>
    );
}

export default Group;
