import React from 'react'
import { Head, useForm } from '@inertiajs/react'
import AppLayout from '@/Layouts/AppLayout'
import Card from '@/Components/Card'
import Input from '@/Components/Input'
import Button from '@/Components/Button'

export default function Create() {
  const { data, setData, post, errors } = useForm({
        activity_no: '',
        relatable_type: '',
        relatable_id: '',
        user_id: '',
        activity_type: '',
        subject: '',
        activity_at: '',
        status: '',
  })

  const submit = (e) => {
    e.preventDefault()
    post(route('apps.activities.store'))
  }

  return (
    <>
      <Head title='Tambah Activity' />
      <Card title='Tambah Activity' form={submit} footer={<Button type='submit' label='Simpan' variant='gray' />}>
        <div className='grid grid-cols-1 md:grid-cols-2 gap-4'>
              <div className='w-full md:w-1/2'>
                <Input label='Activity No' type='text' value={data.activity_no} onChange={e => setData('activity_no', e.target.value)} errors={errors.activity_no} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Relatable Type' type='text' value={data.relatable_type} onChange={e => setData('relatable_type', e.target.value)} errors={errors.relatable_type} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Relatable ID' type='text' value={data.relatable_id} onChange={e => setData('relatable_id', e.target.value)} errors={errors.relatable_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='User ID' type='text' value={data.user_id} onChange={e => setData('user_id', e.target.value)} errors={errors.user_id} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Activity Type' type='text' value={data.activity_type} onChange={e => setData('activity_type', e.target.value)} errors={errors.activity_type} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Subject' type='text' value={data.subject} onChange={e => setData('subject', e.target.value)} errors={errors.subject} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Activity At' type='datetime-local' value={data.activity_at} onChange={e => setData('activity_at', e.target.value)} errors={errors.activity_at} />
              </div>
              <div className='w-full md:w-1/2'>
                <Input label='Status' type='text' value={data.status} onChange={e => setData('status', e.target.value)} errors={errors.status} />
              </div>
        </div>
      </Card>
    </>
  )
}

Create.layout = page => <AppLayout children={page} />
