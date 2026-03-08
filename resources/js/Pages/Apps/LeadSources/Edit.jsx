import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Edit({ leadSource }) {
  const { data, setData, put, errors } = useForm({
        code: leadSource.code ?? '',
        name: leadSource.name ?? '',
        description: leadSource.description ?? '',
        is_active: leadSource.is_active ?? '',
  })

  const submit = (e) => {
    e.preventDefault()
    put(route('apps.lead-sources.update', leadSource.id))
  }

  return (
    <>
      <Head title='Edit Lead Source' />
      <Card title='Edit Lead Source' form={submit} footer={<Button type='submit' label='Update' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Kode' type='text' value={data.code} onChange={e => setData('code', e.target.value)} errors={errors.code} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Nama' type='text' value={data.name} onChange={e => setData('name', e.target.value)} errors={errors.name} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Deskripsi' type='text' value={data.description} onChange={e => setData('description', e.target.value)} errors={errors.description} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Aktif (0/1)' type='text' value={data.is_active} onChange={e => setData('is_active', e.target.value)} errors={errors.is_active} />
              </div>
        </div>
      </Card>
    </>
  )
}

Edit.layout = page => <AppLayout children={page} />
