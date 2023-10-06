import React, { useState, useEffect } from 'react';
import { getSemester } from '../services/api';
import { useRoute } from 'wouter';

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/admin/:id');

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);
        });
    }, [params.id]);

    const [openMenus, setOpenMenus] = useState({});

    const toggleMenu = (subjectId) => {
        setOpenMenus((prevOpenMenus) => ({
            ...prevOpenMenus,
            [subjectId]: !prevOpenMenus[subjectId]
        }));
    };

    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div>
                    <ul>
                        {semester.subject.map((subject) => {
                            const subjectId = subject['@id'].split('/').pop();

                            return (
                                <React.Fragment key={subjectId}>
                                    <li
                                        className="semester-li"
                                        onClick={() => toggleMenu(subjectId)}
                                    >
                                        {subject.subjectCode + ' - ' + subject.name}
                                    </li>
                                    {openMenus[subjectId] && (
                                        <li className="menu-li">
                                            <div className="menu">Contenu du menu à droite</div>
                                        </li>
                                    )}
                                </React.Fragment>
                            );
                        })}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default Semester;
