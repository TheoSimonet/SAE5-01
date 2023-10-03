import React, {useState, useEffect} from 'react';
import {fetchGroups} from '../services/api';
import {Link} from 'wouter';
import "../../styles/semesterList.css"
function Grouplist() {
    const [groups, setGroups] = useState(null);

    useEffect(() => {
        fetchGroups().then((data) => {
            if (data && data["hydra:member"]) {
                setGroups(data["hydra:member"]);
            }
        });
    }, []);

    return (
        <div className={"subjectList"}>
            {groups ===null ? 'ça charge ou quoi ?!' :
                groups.map((group) => (
                        <div key={group.id}>
                            <Link href={`/react/subjects/${group.id}`}>
                                {group.lib}
                            </Link>
                        </div>
                    )
                )
            }
        </div>
    );
}

export default Grouplist;
