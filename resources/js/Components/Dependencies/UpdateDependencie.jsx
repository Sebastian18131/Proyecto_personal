import React, { useContext, useState } from "react";
import { DependenciesContext } from "@/context/DependenciesContext/DependenciesContext";
import { CheckIcon } from "@heroicons/react/24/outline";
import { toast } from "sonner";

export default function UpdateDependencie({ dependency }) {
    const { editDependency } = useContext(DependenciesContext);

    const [name, setName] = useState(dependency.name);
    const [code, setCode] = useState(dependency.code || "");
    const [loading, setLoading] = useState(false);

    const isDirty = (name.trim() !== dependency.name || code.trim() !== (dependency.code || "")) && name.trim() !== "" && code.trim() !== "";

    const handleUpdate = async () => {
        if (!isDirty) return;
        setLoading(true);
        const ok = await editDependency(dependency.id, { 
            name: name.trim(),
            code: code.trim().toUpperCase()
        });
        if (ok?.success !== false) {
            toast.success("Dependencia actualizada");
        } else {
            toast.error("No se pudo actualizar la dependencia");
        }
        setLoading(false);
    };

    return (
        <div className="flex items-end gap-2">
            <div className="flex flex-col gap-1.5">
                <label className="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Renombrar
                </label>
                <input
                    type="text"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    className="input input-bordered input-sm"
                    placeholder="Nuevo nombre"
                />
            </div>
            <div className="flex flex-col gap-1.5 w-24">
                <label className="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Código
                </label>
                <input
                    type="text"
                    value={code}
                    onChange={(e) => setCode(e.target.value)}
                    className="input input-bordered input-sm font-mono uppercase"
                    placeholder="Código"
                />
            </div>
            <button
                onClick={handleUpdate}
                disabled={loading || !isDirty}
                className="btn btn-primary btn-sm gap-1.5 text-white disabled:opacity-40"
            >
                {loading ? (
                    <span className="loading loading-spinner loading-xs" />
                ) : (
                    <CheckIcon className="size-4" />
                )}
                Guardar
            </button>
        </div>
    );
}