import React, { useState, useEffect } from 'react';
import { getSemester } from '../services/api';
import { useRoute } from 'wouter';

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);
        });
    }, [params.id]);

    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div>
                    <ul>
                        {semester.subject.map((subject) => {
                            const subjectId = subject['@id'].split('/').pop();

                            return (
                                <li key={subjectId} className="semester-li">
                                    {subject.subjectCode + ' - ' + subject.name}
                                    <br/><br/>
                                    <p className="groupe">Groupes |</p>
                                    <div className="Postuler-container">
                                        <a href={`/wish/new?subjectId=${subjectId}`} className="ajouter-button">Postuler</a>
                                    </div>
                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default Semester;
