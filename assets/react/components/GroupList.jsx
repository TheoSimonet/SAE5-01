import React, { useState, useEffect } from 'react';
import { fetchGroups } from '../services/api';
import {Link} from "wouter";

function Grouplist() {
    const [groups, setGroups] = useState([]);

    useEffect(() => {
        fetchGroups().then((data) => {
            if (data && data.length > 0) {
                setGroups(data);
            }
        });
    }, []);

    return (
        <div className={"semesterList"}>
            {groups ===null ? 'Loading...' :
            groups.map((group) => (
                        <div key={group.type}>
                            <Link href={`/react/groups/${group.id}`}>
                                {group.type}
                            </Link>
                        </div>
                    )
                )
            }
        </div>

    );
}

export default Grouplist;
