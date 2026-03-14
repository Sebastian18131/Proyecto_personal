// ModalCreateOrEditFolder is a modal dialog for creating a new folder or editing an existing folder's details within the archive explorer.
import { useExplorerData } from '@/Hooks/useExplorer';
import React, { useState, useEffect } from 'react'
import { toast } from 'sonner';

const ModalCreateOrEditFolder = () => {

    const {
        currentFolder,
        createFolder,
        updateFolder,
        selectedItems,
        folders,
        historyStack
    } = useExplorerData();

    const [loading, setLoading] = useState(false);

    const [formData, setFormData] = useState({
        name: "",
        folder_code: "",
        department: "sección",
    });

    const selected =
        selectedItems.length === 1 && selectedItems[0].type === 'folder'
            ? folders.find(f => f.id === selectedItems[0].id)
            : null;


    const createFolderSubmit = async (e) => {
        e.preventDefault();
        document.getElementById("drawer-information").close();
        setLoading(true);

        try {
            let dept = formData.department;
            if (!selected) {
                dept = historyStack?.length === 0 ? "sección" : 
                       historyStack?.length === 1 ? "dependencia" :
                       historyStack?.length === 2 ? "serie" :
                       historyStack?.length === 3 ? "subserie" : "subserie";
            }

            const data = {
                name: formData.name,
                folder_code: formData.folder_code,
                parent_id: currentFolder?.id || null,
                department: dept,
            };

            await createFolder({ data });
            setFormData({ name: "", folder_code: "", department: "sección" });
            document.getElementById('createFolder').close();

        } catch (err) {
            toast.error("Error al crear la carpeta: " + err.message);
        } finally {
            setLoading(false);
        }
    };


    const editFolderSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        document.getElementById("drawer-information").close();

        try {
            const data = {
                name: formData.name,
                folder_code: formData.folder_code,
                parent_id: currentFolder?.id || null,
                department: formData.department,
            };


            await updateFolder({
                data,
                folderId: selected.id,
            });
            document.getElementById('createFolder').close();

        } catch (err) {
            toast.error(err?.message || "Error al editar la carpeta");
        } finally {
            setLoading(false);
        }
    };

    const handleCancel = () => {
        setLoading(false);
        document.getElementById('createFolder').close();
    };

    useEffect(() => {
        if (selected) {
            setFormData({
                name: selected.name || "",
                folder_code: selected.folder_code || "",
                department: selected.department || "sección",
            });
        } else {
            setFormData({
                name: "",
                folder_code: "",
                department: "sección",
            });
        }
    }, [selected]);



    return (
        <dialog id='createFolder' className='modal'>
            <div className='modal-box'>

                <button
                    className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                    onClick={handleCancel}
                >
                    ✕
                </button>

                <h2 className='text-2xl font-bold text-center mb-4'>
                    {selected ? "Editar Carpeta" : "Crear Carpeta"}
                </h2>

                {historyStack?.length >= 4 && !selected && (
                    <div className="alert alert-warning text-sm mb-4">
                        Ha alcanzado el nivel máximo de subcarpetas (Subserie). En este nivel solo debe subir archivos.
                    </div>
                )}

                <form
                    className='flex flex-col gap-8'
                    onSubmit={selected ? editFolderSubmit : createFolderSubmit}
                >
                    <div className='flex flex-col space-y-2'>
                        <label>Nombre de la Carpeta:</label>
                        <input
                            required
                            type="text"
                            className='border border-gray-300 rounded-md p-2'
                            placeholder='Ejem: Actas'
                            value={formData.name}
                            onChange={(e) =>
                                setFormData({ ...formData, name: e.target.value })
                            }
                        />
                    </div>

                    <div className='flex flex-col space-y-2'>
                        <label>Código de la Carpeta:</label>
                        <input
                            required
                            type="text"
                            className='border border-gray-300 rounded-md p-2'
                            placeholder='Ejem: 110'
                            value={formData.folder_code}
                            onChange={(e) =>
                                setFormData({ ...formData, folder_code: e.target.value })
                            }
                        />
                    </div>

                    <div className='flex flex-col space-y-2'>
                        <label>Clasificación (Nivel actual: {
                            historyStack?.length === 0 ? "Año" :
                            historyStack?.length === 1 ? "Dependencia" :
                            historyStack?.length === 2 ? "Serie" :
                            historyStack?.length === 3 ? "Subserie" : "Desconocido"
                        }):</label>
                        <select
                            className='border border-gray-300 rounded-md p-2 bg-gray-100 text-gray-700'
                            value={
                                historyStack?.length === 0 ? "sección" : // Usamos sección como Año
                                historyStack?.length === 1 ? "dependencia" :
                                historyStack?.length === 2 ? "serie" :
                                historyStack?.length === 3 ? "subserie" : formData.department
                            }
                            onChange={(e) =>
                                setFormData({ ...formData, department: e.target.value })
                            }
                            required
                            disabled={!selected} /* Force them to use the mapped classification for new folders */
                        >
                            <option value="sección">Año (Sección)</option>
                            <option value="dependencia">Dependencia</option>
                            <option value="subsección">Subsección</option>
                            <option value="serie">Serie</option>
                            <option value="subserie">Subserie</option>
                        </select>
                    </div>


                    <div className='flex justify-center'>
                        <button
                            className='bg-primary text-white rounded-md px-4 py-2'
                            type='submit'
                            disabled={loading}
                        >
                            {loading
                                ? selected ? "Editando..." : "Creando..."
                                : selected ? "Guardar" : "Crear"}
                        </button>
                    </div>
                </form>
            </div>

            <form method="dialog" className="modal-backdrop" onClick={handleCancel}>
                <button>close</button>
            </form>
        </dialog>
    );
};

export default ModalCreateOrEditFolder;
